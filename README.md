# Laravel OOP Drills

Daily, deliberate practice on SOLID principles and design patterns applied to
Laravel/PHP, built one small drill at a time.

Each day tackles one concept, applies it to a small working example, and logs
an interview-style scenario question with its answer in `FAQ.md`.

## Structure

- `src/Contracts/` - interfaces
- `src/Services/` - business logic
- `src/Factories/` - object-construction decision logic
- `src/Models/` - domain entities (no persistence, no framework)
- `src/Http/Controllers/` - thin controllers
- `docs/` - per-topic notes
- `FAQ.md` - scenario questions and answers, written for interview prep
- `scratch.php` - manual run script (`php scratch.php`)

## Setup

```bash
composer dump-autoload
php scratch.php
```

## Progress

- **Day 1** - Composition vs Inheritance
- **Day 2** - Single Responsibility Principle (refactoring a "god" Controller)
