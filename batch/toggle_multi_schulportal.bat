@echo off
setlocal enabledelayedexpansion

set "hosts_file=C:\Users\flx\Desktop\hoststest"

REM Definiere das assoziative Array mit den Suchstrings und den entsprechenden Einträgen
set "entries[FRITZBOX]=FRITZBOX"
set "entries[12.33.44.1]=12.33.44.1 my Hostname # this is so cool"
set "entries[search_string3]=entry_to_add3"

set "temp_file=%temp%\temp_hosts.txt"
set "found=false"

REM Durchlaufe die "hosts"-Datei Zeile für Zeile
for /f "usebackq delims=" %%a in ("%hosts_file%") do (
    set "zeile=%%a"
    set "line_found=false"
    
    REM Überprüfe jede Zeile auf Übereinstimmung mit den Suchstrings im assoziativen Array
    for /f "tokens=2 delims== " %%b in ('echo %%zeile%%') do (
        REM Überprüfe, ob der aktuelle Suchstring in der Zeile vorhanden ist
        for /f "tokens=1,* delims==" %%c in ('set entries[search_string]') do (
            if "%%b"=="%%c" (
                REM Entferne die Zeile, wenn der Suchstring gefunden wurde
                echo Zeile mit '%%c' gefunden und entfernt.
                set "line_found=true"
            )
        )
    )
    
    if not !line_found! == true (
        REM Füge die Zeile hinzu, wenn keiner der Suchstrings gefunden wurde
        echo !zeile!>>"%temp_file%"
    )
)

REM Füge die Zeilen für die Suchstrings hinzu, die nicht gefunden wurden
for /f "tokens=2 delims== " %%d in ('set entries[search_string]') do (
    set "entry_found=false"
    
    REM Überprüfe, ob der aktuelle Suchstring in der "hosts"-Datei vorhanden ist
    for /f "usebackq delims=" %%a in ("%hosts_file%") do (
        echo %%a | findstr /i /c:"%%d" >nul
        if errorlevel 0 (
            set "entry_found=true"
            exit /b
        )
    )
    
    REM Füge die Zeile hinzu, wenn der Suchstring nicht gefunden wurde
    if not !entry_found! == true (
        echo %%d>>"%temp_file%"
    )
)

REM Ersetze die ursprüngliche "hosts"-Datei mit der aktualisierten Datei
move /y "%temp_file%" "%hosts_file%" >nul
PAUSE
endlocal