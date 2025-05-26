import { Capacitor } from '@capacitor/core';
import { StatusBar, Style } from '@capacitor/status-bar';

export const setupStatusBar = async (
  isCheckingAuth: boolean,
  hasBootstrapped: boolean,
  isBootstrapping: boolean,
  authUser: any
) => {
  if (Capacitor.getPlatform() !== 'web') {
    let color = '#ffffff';
    let colorText = Style.Light;

    if (!authUser) {
      color = '#214360'; 
      colorText = Style.Dark;
    } else if (isCheckingAuth || isBootstrapping || !hasBootstrapped) {
      color = '#eeeeee'; 
    }

    await StatusBar.setStyle({ style: colorText });
    await StatusBar.setBackgroundColor({ color });
  }
};
