import { loadEnv } from "vite";
import fs from "fs";
import { homedir } from "os";
import { resolve } from "path";

export function getValetHome() {
    let valetPath = resolve(homedir(), ".config/valet");
    if (fs.existsSync(valetPath)) {
        return valetPath;
    }

    valetPath = resolve(homedir(), ".valet");
    if (fs.existsSync(valetPath)) {
        return valetPath;
    }

    return null;
}

// Variation of https://freek.dev/2276-making-vite-and-valet-play-nice-together
export function detectServerConfig(mode) {
    const valetPath = getValetHome();
    if (!valetPath) {
        return;
    }

    const host = loadEnv(mode, process.cwd()).VITE_HOST ?? "localhost";
    let keyPath = resolve(valetPath, `Certificates/${host}.key`);
    let certificatePath = resolve(valetPath, `Certificates/${host}.crt`);

    if (!fs.existsSync(keyPath)) {
        return;
    }

    if (!fs.existsSync(certificatePath)) {
        return;
    }

    return {
        host,
        port: 3000,
        https: {
            key: fs.readFileSync(keyPath),
            cert: fs.readFileSync(certificatePath),
        },
    };
}
