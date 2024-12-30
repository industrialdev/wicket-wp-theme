@echo off
setlocal

:: When called from composer, we're in the project root
:: Ensure directories exist
if not exist ".git\hooks" mkdir ".git\hooks"

:: Create symbolic links for all hooks
for %%h in (pre-commit) do (
    :: Remove existing hook if it exists
    if exist ".git\hooks\%%h" del ".git\hooks\%%h"

    :: Create symbolic link (requires admin privileges)
    mklink ".git\hooks\%%h" ".ci\hooks\%%h" > nul 2>&1

    if errorlevel 1 (
        echo Failed to create symbolic link for %%h. Please run as administrator.
    ) else (
        :: Create empty hook file if it doesn't exist
        if not exist ".ci\hooks\%%h" type nul > ".ci\hooks\%%h"
    )
)

echo Git hooks installed successfully!
