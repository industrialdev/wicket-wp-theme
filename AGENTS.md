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

## Release Process (Automated)

Releases are **fully automated**. Merging a PR to `main` cuts a release via the `wicket-release-bot` GitHub App: it bumps the version, prepends `CHANGELOG.md`, commits `chore(release): x.y.z`, and pushes the matching git tag. No one needs push access to `main`.

**Never do these by hand:** bump the version, edit `composer.json` / the main file header / `*_VERSION` constants (and `style.css` for the theme), or create git tags. The bot owns all of that after merge.

### Releasing (default behavior)

Every PR merged to `main` releases automatically with a **patch** bump. Control the bump by putting a marker in the **PR title** (squash-merge makes the title the commit message):

| Marker | Result |
|---|---|
| _(none)_ | patch (`2.4.10` -> `2.4.11`) |
| `#minor` | minor (`2.4.10` -> `2.5.0`) |
| `#major` | major (`2.4.10` -> `3.0.0`) |
| `#norelease` | no bump, no tag |

### Not releasing

Add `#norelease` to the PR title for docs/tooling-only changes that should not cut a version. **Every merge releases unless the message contains `#norelease`.**

### Commit conventions that affect the changelog

- Use conventional prefixes: `feat:`, `fix:`, `docs:`, `chore:`, `perf:`, `refactor:`, etc. The changelog groups entries by prefix.
- `feat!:` (or any `!:`) flags a **BREAKING** change in the changelog.
- **Squash-merge** yields the cleanest changelog (one PR = one line). Merge commits list each individual commit.
- A release lists **everything merged since the last tag**, not just the triggering PR. Catch-up is expected.

### Local version bump (optional)

`composer version-bump` (or `php .ci/version-bump.php`) edits version files only; it never commits or tags. Use it to preview, not to release.

Full details, markers, and troubleshooting: [`docs/engineering/release-automation.md`](docs/engineering/release-automation.md).
