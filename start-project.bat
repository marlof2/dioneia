@echo off
echo ========================================
echo    Iniciando Projeto Dioneia
echo ========================================
echo.
echo Aguarde, iniciando o projeto completo...
echo.
echo O projeto estara disponivel em: http://localhost:8000
echo Para parar o servidor, pressione Ctrl+C
echo.
start http://localhost:8000
composer run dev
pause
