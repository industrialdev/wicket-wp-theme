# Repository Guidelines

## Project Structure & Module Organization

This repository is the Wicket parent theme (`wicket-wp-theme`).
- Theme entry/templates: root PHP files like `functions.php`, `header.php`, `footer.php`, `single.php`.
- Domain logic: `src/` (PSR-4 namespace `WicketTheme\`), plus `custom/` for WordPress hooks/helpers.
- Block code: `blocks/<block-name>/` with `block.json`, `init.php`, and optional `render.php`.
- Frontend assets: `assets/styles/`, `assets/scripts/`, `assets/images/`; built outputs in `assets/scripts/min/` and CSS artifacts.
- Tests: `tests/unit/` (Pest + PHPUnit), optional browser suite in `tests/browser/`.
- `docs/`: public end-user guides only.

For the package map (block template inventory, styling architecture, custom hooks): `@see atlas://packages/wicket-wp-theme.md`. Follow PHP doc conventions per `@see atlas://conventions/php-doc-comment-style.md`. Atlas is the single knowledge base for all Wicket documentation; the repo docs/ folder carries only public end-consumer guides.

## Build, Test, and Development Commands

- `yarn` installs Node dependencies (Node 18.20.7, Yarn 4.7.0 via Volta).
- `yarn gulp` runs the default asset pipeline and watcher; `yarn gulp build` is a one-off production build.
- `composer install` installs PHP dependencies.
- `composer test` / `composer test:unit` run the Pest suites.
- `composer lint` / `composer format` check / fix PHP formatting (php-cs-fixer).
- `composer setup-hooks` installs `.ci/pre-push`.

## Coding Style & Naming Conventions

- Respect `.editorconfig`: 4 spaces by default, 2 for CSS/SCSS/JSON/YAML, LF line endings.
- PHP style enforced by PHP-CS-Fixer (`@PSR12`, `@PER-CS`, PHP 8.2 migration rules); prefer `declare(strict_types=1);` in new files.
- Verb-based method names (`getUserData`), noun-based variables (`userData`).
- Keep WordPress code idiomatic: sanitize inputs, validate data, escape output.

## Testing Guidelines

- Pest on top of PHPUnit 12 (`phpunit.xml`); unit tests in `tests/unit` end with `*Test.php`.
- Add/update tests for logic in `src/` and any non-trivial behavior change; run `composer test` before opening a PR.

## Release & Branch Workflow

All work happens on branches. `main` is locked; changes land via peer-reviewed Pull Request. Never commit to `main` directly, and never push or open a PR without explicit human approval. Keep commits scoped to one concern. PR descriptions use the repo `.github/PULL_REQUEST_TEMPLATE.md`; full rules, including the title format: `@see atlas://conventions/pr-template.md`.

Merging a PR to `main` **auto-releases** via the `wicket-release-bot` GitHub App: version bump, `CHANGELOG.md` update, git tag. Never bump versions, edit `composer.json`, the main file header, `*_VERSION` constants, or `style.css`, and never create tags by hand. The bump level comes from a marker in the PR title (squash-merge makes it the commit message): _(none)_ / `#patch` = patch, `#minor`, `#major`, or `#norelease` (no release; use for docs/tooling-only merges). Conventional commit prefixes (`feat:`, `fix:`, `docs:`, ...) drive changelog grouping; a `!` (e.g. `feat!:`) flags a BREAKING change. Full rules: `@see atlas://conventions/release-automation.md`.
