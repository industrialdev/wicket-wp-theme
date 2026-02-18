# Repository Guidelines

## Project Structure & Module Organization
This repository is a WordPress theme (`wicket-wp-theme`).
- Theme entry/templates: root PHP files like `functions.php`, `header.php`, `footer.php`, `single.php`.
- Domain logic: `src/` (PSR-4 namespace `WicketTheme\\`), plus `custom/` for WordPress hooks/helpers.
- Block code: `blocks/<block-name>/` with `block.json`, `init.php`, and optional `render.php`.
- Frontend assets: `assets/styles/`, `assets/scripts/`, `assets/images/`, built outputs in `assets/scripts/min/` and CSS artifacts.
- Tests: `tests/unit/` (Pest + PHPUnit), optional browser suite in `tests/browser/`.

## Build, Test, and Development Commands
- `yarn` installs Node dependencies (Node `18.20.7`, Yarn `4.7.0` via Volta).
- `yarn gulp` runs the default asset pipeline and file watcher.
- `yarn gulp build` runs a one-off production-style asset build.
- `composer install` installs PHP dependencies.
- `composer test` runs all Pest suites.
- `composer test:unit` runs unit tests only.
- `composer lint` checks PHP formatting (`php-cs-fixer --dry-run --diff`).
- `composer format` applies PHP formatting fixes.
- `composer setup-hooks` installs `.ci/pre-push`.

## Coding Style & Naming Conventions
- Respect `.editorconfig`: 4 spaces by default, 2 for CSS/SCSS/JSON/YAML, LF line endings.
- PHP style is enforced by PHP-CS-Fixer (`@PSR12`, `@PER-CS`, PHP 8.2 migration rules). Prefer `declare(strict_types=1);` in new PHP files.
- Use verb-based method names (`getUserData`) and noun-based variables (`userData`).
- Keep WordPress code idiomatic: sanitize inputs, validate data, escape output.

## Testing Guidelines
- Framework: Pest on top of PHPUnit 12 (`phpunit.xml`).
- Unit tests live in `tests/unit` and should end with `*Test.php`.
- Add/update tests for logic in `src/` and any non-trivial behavior changes.
- Run `composer test` before opening a PR.

## Commit & Pull Request Guidelines
- Follow existing history style: short, descriptive subject lines (for example, `Fix mobile nav link clickability`).
- Keep commits scoped to one concern; avoid mixing refactors and behavior changes.
- PRs should include:
  - Clear summary of behavior change
  - Linked issue/ticket (if available)
  - Screenshots for UI/template changes
  - Notes on test coverage and any manual verification steps
