#!/bin/bash

# Выполнить PHP-скрипт
php index.php

# Проверить, был ли успешно создан JSON файл
if [ -f "formData.json" ]; then
    echo "formData.json successfully created. Running login.js..."

    # Выполнить JavaScript-скрипт
    node login.js
else
    echo "Failed to create formData.json. Exiting..."
    exit 1
fi
