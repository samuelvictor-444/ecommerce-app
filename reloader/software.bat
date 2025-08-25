@echo off 

cd /d C:\xampp\htdocs\usman_clothing_service
browser-sync start --proxy "http://localhost/usman_clothing_service" --files "**/*.php" "**/*.css" "**/*.js"
pause