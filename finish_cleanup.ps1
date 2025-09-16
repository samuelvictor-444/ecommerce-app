# 1️⃣ Add SMTP file to .gitignore
$SmtpFile = "api/includes/send_email.php"
if (-not (Select-String -Path ".gitignore" -Pattern [regex]::Escape($SmtpFile))) {
    Add-Content -Path ".gitignore" -Value $SmtpFile
    Write-Host "`nAdded $SmtpFile to .gitignore"
} else {
    Write-Host "`n$SmtpFile already in .gitignore"
}

# 2️⃣ Commit .gitignore update if there are changes
git add .gitignore
$diff = git diff --cached --name-only
if ($diff) {
    git commit -m "Add SMTP file to .gitignore to prevent future leaks"
    Write-Host "`nCommitted .gitignore update"
} else {
    Write-Host "`nNo changes to commit for .gitignore"
}

# 3️⃣ Restore stashed changes
$stashes = git stash list
if ($stashes) {
    git stash pop
    Write-Host "`nRestored stashed changes"
} else {
    Write-Host "`nNo stashed changes to restore"
}

# 4️⃣ Push updates to GitHub
git push origin main
Write-Host "`nPushed main branch to origin"
