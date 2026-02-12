#!/bin/bash

# When called from composer, we're in the project root
# Ensure .git/hooks directory exists
mkdir -p ".git/hooks"

# Install pre-commit hook (from .ci/hooks)
if [ -f ".ci/hooks/pre-commit" ]; then
    ln -sf "../.ci/hooks/pre-commit" ".git/hooks/pre-commit"
    chmod +x "../.ci/hooks/pre-commit"
fi

# Install pre-push hook (from .ci)
if [ -f ".ci/pre-push" ]; then
    cp ".ci/pre-push" ".git/hooks/pre-push"
    chmod +x ".git/hooks/pre-push"
fi

echo "Git hooks installed successfully!"
