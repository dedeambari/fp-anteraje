import type { CapacitorConfig } from "@capacitor/cli";
import { KeyboardResize } from '@capacitor/keyboard';

const config: CapacitorConfig = {
	appId: "com.antaraje",
	appName: "AntarAje",
	webDir: "dist",
	plugins: {
		Keyboard: {
			resize: KeyboardResize.Native,
			resizeOnFullScreen: true
		}
	},
	server: {
		url: "http://192.168.117.15:5173",
		cleartext: true
	}
};

export default config;
