# Script para criar atalho na área de trabalho
$WshShell = New-Object -comObject WScript.Shell

# Obter o caminho da área de trabalho
$Desktop = $WshShell.SpecialFolders.Item("Desktop")

# Obter o caminho atual do projeto
$CurrentPath = (Get-Location).Path

# Criar atalho para iniciar o projeto completo
$Shortcut = $WshShell.CreateShortcut("$Desktop\Dioneia - Iniciar Projeto.lnk")
$Shortcut.TargetPath = "$CurrentPath\start-project.bat"
$Shortcut.WorkingDirectory = $CurrentPath
$Shortcut.Description = "Iniciar projeto Laravel Dioneia (composer run dev)"
$Shortcut.IconLocation = "C:\Program Files\PHP\php.exe,0"
$Shortcut.Save()

Write-Host "Atalho criado na área de trabalho!" -ForegroundColor Green
Write-Host "Dioneia - Iniciar Projeto (composer run dev)" -ForegroundColor Yellow
