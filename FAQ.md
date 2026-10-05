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
