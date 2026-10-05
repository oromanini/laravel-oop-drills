# What is composition

Composition is the principle of building behavior by combining independent objects through their interfaces, rather than
inheriting behavior from a superclass.

It's the foundation of the design guideline "favor composition over inheritance" (Gang of Four, Design Patterns, 1994),

because inheritance creates tight coupling at definition time
between base and derived classes (the fragile base class problem),
while composition lets you swap behavior at runtime via dependency injection.

# When does composition solve a problem inheritance can't?

When I need to combine or swap behaviors independently - like combining discount rules, or notifying
through multiple channels at once. With inheritance I'd need a new subclass for every combination.
With composition I just inject a different object implementing the same interface.
My Order class never changes, regardless of which DiscountRule it receives.

# Why not implement the discount with inheritance instead?

With inheritance, VipOrder would extend Order and override total():

    class Order {
        public function total(): float { return $this->grossAmount; }
    }

    class VipOrder extends Order {
        public function total(): float { return $this->grossAmount * 0.85; }
    }

This breaks down fast for three reasons:

1. Combinations explode. A VIP customer with a coupon needs a new
   subclass (VipOrderWithCoupon), and every new rule multiplies the
   subclasses needed. With composition, I just inject multiple
   DiscountRule objects - no new classes.

2. Can't swap at runtime. Once an object is a VipOrder, it stays one.
   If VIP status expires mid-session, I'd have to destroy and recreate
   the object. With composition, I just swap the injected rule.

3. Fragile base class. If Order::total() changes internally, every
   subclass that calls parent::total() can break unexpectedly, because
   they're coupled to the base class's exact implementation.

Inheritance models "is-a" relationships fixed at definition time.
Composition models "has-a" relationships that can change at runtime.

# How does composition resolve the VipOrderWithCoupon case?

Option A - Order takes an array of rules and applies them in sequence:

    class Order {
        public function __construct(
            private readonly float $grossAmount,
            private readonly array $rules // array of DiscountRule
        ) {}

        public function total(): float {
            $amount = $this->grossAmount;
            foreach ($this->rules as $rule) {
                $amount = $rule->calculate($amount);
            }
            return $amount;
        }
    }

    $order = new Order(100.0, [new VipDiscount(), new CouponDiscount()]);

No new class needed for the combination - just pass more rules into the array.

Option B - a CompositeDiscount (the Composite design pattern): a discount
rule that is itself made of other discount rules.

    class CompositeDiscount implements DiscountRule {
        private array $rules;

        public function __construct(DiscountRule ...$rules) {
            $this->rules = $rules;
        }

        public function calculate(float $amount): float {
            foreach ($this->rules as $rule) {
                $amount = $rule->calculate($amount);
            }
            return $amount;
        }
    }

    $combined = new CompositeDiscount(new VipDiscount(), new CouponDiscount());
    $order = new Order(100.0, $combined);

Option B is the stronger interview answer: Order's constructor signature
never changes, it always takes a single DiscountRule. The complexity of
how many discounts and in what order is pushed into the composite object,
instead of leaking into Order.

# How do I spot and separate responsibilities when a controller becomes a "God object"?

The Single Responsibility Principle says a class should have one reason to
change. A Laravel controller violates this constantly, because it's the
first thing that receives the request, which makes it the easiest place to
dump unrelated logic.

A "God controller" typically mixes five responsibilities in one method:

1. Validation
2. Business logic (discount rules, pricing)
3. Persistence (saving the model)
4. Side effects (sending an email, writing a log)
5. Response formatting

For example, an `OrderController::store()` that validates the request,
applies a VIP discount inline, builds and saves an `Order` model, sends a
confirmation email, logs the action, and returns a JSON response - all in
one method - has at least five reasons to change. A pricing rule change, a
new notification channel, and a validation rule change all touch the same
method.

The fix is to extract each responsibility into its own class with a single
job:

- Validation stays in the controller (or a Form Request in a real Laravel
  app) - it's about the HTTP layer, not the business.
- Business logic moves to a Service (`OrderService`), which depends on a
  Factory to decide which rule to apply.
- The decision of *which* `DiscountRule` to construct moves to a Factory
  (`DiscountRuleFactory`), so the Service never has conditionals about VIP
  status or coupons - it just asks the Factory for a rule and applies it.
- Persistence and side effects (Mail, Log) are out of scope for this
  drill, but in a real app they'd move to the Model/Repository and to
  Events/Listeners or Jobs, respectively.

After the refactor, `OrderController::store()` has one job: translate an
HTTP request into a call to `OrderService` and translate the result back
into a response. Each class now has exactly one reason to change.

# Why does OrderService depend on DiscountRuleFactory instead of building the DiscountRule itself?

Because deciding *which* discount rule applies (VIP? coupon? both?) is a
separate responsibility from applying one. If `OrderService` had an
`if ($isVip) { ... }` chain inline, every new combination of rules would
mean editing `OrderService` directly, and the same decision logic could
drift out of sync if it's duplicated anywhere else that needs to build a
`DiscountRule`.

By injecting `DiscountRuleFactory` as a constructor dependency:

- `OrderService` stays focused on orchestrating the order flow (ask the
  Factory for a rule, apply it, return the total).
- The Factory is the single, reusable source of truth for "how do I build
  the right DiscountRule for this combination of flags."
- Adding a new rule (e.g., a seasonal promotion) means changing the
  Factory's `match` expression in one place, not hunting through every
  class that happens to build discount rules.

This follows the same constructor-vs-method-parameter rule used
throughout this project: constructor = stable, shared dependency
(Services, Factories, Repositories); method parameters = data that
changes per request (`$amount`, `$isVip`, `$hasCoupon`).
