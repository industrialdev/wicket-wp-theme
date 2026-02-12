@echo off
setlocal

:: When called from composer, we're in the project root
:: Ensure directories exist
if not exist ".git\hooks" mkdir ".git\hooks"

:: Install pre-commit hook (copy, no symlinks on Windows)
if exist ".ci\hooks\pre-commit" (
    copy /Y ".ci\hooks\pre-commit" ".git\hooks\pre-commit" > nul
)

:: Install pre-push hook
if exist ".ci\pre-push" (
    copy /Y ".ci\pre-push" ".git\hooks\pre-push" > nul
)

echo Git hooks installed successfully!
