@echo off
chcp 1252 > nul
setlocal enabledelayedexpansion
echo Bearbeiten von etc\hosts für die lokale Testumgebung der Loginplattform

net session >nul 2>&1
if %errorLevel% neq 0 (
    echo Dieses Script muss mit erhöhten Privilegien ausgeführt werden.
    PAUSE
    exit /b
)

set /p sp_host=IP von 'login.schulportal.sachsen.de' (Leerlassen toggelt die Zeile mittels Kommentar):
set /p idp_host=IP von 'schule.sachsen.de' (Leerlassen toggelt die Zeile mittels Kommentar):
set /p hosts_abs_path=absolute path for hosts file (Leerlassen = C:\Windows\System32\drivers\etc\hosts):
set /p confirm=Wissen Sie wirklich, was tun (J)?
PAUSE
BREAK

if "%hosts_abs_path%"=="" (
    set "hosts_file=C:\Windows\System32\drivers\etc\hosts"
) else (
    set "hosts_file=%hosts_abs_path%"
)
set "search_string_sp=loginplattform"
set "search_string_idp=schulportal"

set "temp_file=%temp%\temp_hosts.txt"
set "found_idp=false"
set "found_sp=false"

set "idp_entry=%idpHost% login.schule.sachsen.de"
set "sp_entry=%spHost% schulportal.sachsen.de"

for /f "usebackq delims=" %%a in ("%hosts_file%") do (

    set "line=%%a"
    
    echo !line! | findstr /i /c:"%search_string_sp%" >nul
    if errorlevel 1 (
        echo !line!>>"%temp_file%"
    ) else (
        set "found_idp=true"
    )

    echo !line! | findstr /i /c:"%search_string_idp%" >nul
    if errorlevel 1 (
        echo !line!>>"%temp_file%"
    ) else (
        set "found_sp=true"
)

if not %found_sp%==true (
    echo %sp_entry%>>"%temp_file%"
)

if not %found_idp%==true (
    echo %idp_entry%>>"%temp_file%"
)

move /y "%temp_file%" "%hosts_file%" >nul

endlocal