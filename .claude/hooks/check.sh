#!/usr/bin/env bash
# Draait na elke Edit/Write. Formatteert alleen gewijzigde PHP-bestanden met Pint.

file=$(jq -r '.tool_input.file_path // empty')

if [[ "$file" == *.php ]]; then
  vendor/bin/pint "$file" --quiet
fi

exit 0
