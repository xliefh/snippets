#include "resource.h"

#include <windows.h>
#include <shlobj.h>
#include <stdio.h>

#pragma comment(lib, "User32.lib")

HWND hList;
HWND hButtonNuke;
HWND hButtonAbort;

void AddDriveToList(char drive) {
    char volumeName[MAX_PATH + 1] = {0};
    char fileSystemName[MAX_PATH + 1] = {0};
    DWORD serialNumber = 0;
    DWORD maxComponentLen = 0;
    DWORD fileSystemFlags = 0;

    char rootPath[] = {drive, ':', '\\', '\0'};
    if (GetVolumeInformation(
        rootPath,
        volumeName,
        sizeof(volumeName),
        &serialNumber,
        &maxComponentLen,
        &fileSystemFlags,
        fileSystemName,
        sizeof(fileSystemName))) {
        ULARGE_INTEGER totalSize = {0};
        if (GetDiskFreeSpaceEx(rootPath, NULL, &totalSize, NULL)) {
            char str[MAX_PATH + 1];
            sprintf(str, "%c: %s (%.1f GB)", drive, volumeName, (double)totalSize.QuadPart / (1024 * 1024 * 1024));
            SendMessage(hList, LB_ADDSTRING, 0, (LPARAM)str);
        }
        else {
            char str[MAX_PATH + 1];
            sprintf(str, "%c: %s", drive, volumeName);
            SendMessage(hList, LB_ADDSTRING, 0, (LPARAM)str);
        }
    }
    else {
        char str[] = {drive, ':', '\0'};
        SendMessage(hList, LB_ADDSTRING, 0, (LPARAM)str);
    }
}


//void AddDriveToList(char drive) {
//    char str[] = {drive, ':', '\0'};
//    SendMessage(hList, LB_ADDSTRING, 0, (LPARAM)str);
//}

BOOL CALLBACK DialogProc(HWND hwndDlg, UINT message, WPARAM wParam, LPARAM lParam) {
    switch (message) {
        case WM_INITDIALOG:
            hList = GetDlgItem(hwndDlg, IDC_LIST1);
            hButtonNuke = GetDlgItem(hwndDlg, IDC_BUTTON1);
            hButtonAbort = GetDlgItem(hwndDlg, IDC_BUTTON2);

            DWORD drives = GetLogicalDrives();
            for (char drive = 'A'; drive <= 'Z'; drive++) {
                if (drives & 1) {
                    char path[] = {drive, ':', '\\', '\0'};
                    AddDriveToList(drive);
                }
                drives >>= 1;
            }
            return TRUE;

        case WM_COMMAND:
            if (LOWORD(wParam) == IDC_BUTTON2) {
                MessageBox(hwndDlg, "Hello World!", "Message", MB_ICONINFORMATION);
            }
            else if (LOWORD(wParam) == IDC_BUTTON1) {
                if (MessageBox(hwndDlg, "Are you sure?", "Confirmation", MB_YESNO | MB_ICONQUESTION) == IDYES) {
                    MessageBox(hwndDlg, "Hi, I am a dummy!", "Message", MB_ICONINFORMATION);
                }
            }
            return TRUE;

        case WM_CLOSE:
            EndDialog(hwndDlg, 0);
            return TRUE;
    }

    return FALSE;
}

int WINAPI WinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance,
                   LPSTR lpCmdLine, int nCmdShow) {
    DialogBox(hInstance, MAKEINTRESOURCE(IDD_DIALOG1), NULL, DialogProc);
    return 0;
}
