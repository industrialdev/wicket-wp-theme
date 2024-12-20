#!/bin/bash

# When called from composer, we're in the project root
# Ensure .git/hooks directory exists
mkdir -p ".git/hooks"

# Create symbolic links for all hooks
for hook in pre-commit; do
    # Force remove existing hook if it exists
    rm -f ".git/hooks/$hook"

    # Create symbolic link (relative from .git/hooks to .ci/hooks)
    ln -sf "../.ci/hooks/$hook" ".git/hooks/$hook"

    # Make the hook executable
    touch ".ci/hooks/$hook"
    chmod +x ".ci/hooks/$hook"
done

echo "Git hooks installed successfully!"
