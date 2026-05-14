import basicSsl from '@vitejs/plugin-basic-ssl';
import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const __dirname = path.dirname(fileURLToPath(import.meta.url));
const vite_status_path = path.join(__dirname, 'storage', 'vite', 'dev-server.local');

function viteDevServerStatus() {
    return {
        name: 'vite-dev-server-status',
        configureServer(server) {
            server.httpServer?.once('listening', () => {
                const address = server.httpServer.address();
                const port = typeof address === 'object' && address !== null ? address.port : server.config.server.port;

                fs.mkdirSync(path.dirname(vite_status_path), { recursive: true });
                fs.writeFileSync(vite_status_path, JSON.stringify({
                    origin: `https://localhost:${port}`,
                    port,
                }));
            });

            server.httpServer?.once('close', () => {
                if (fs.existsSync(vite_status_path)) {
                    fs.unlinkSync(vite_status_path);
                }
            });
        },
    };
}

export default {
    plugins: [basicSsl(), viteDevServerStatus()],
    // config options
    server: {
        port: 1337,
        strictPort: false,
        https: true,
        cors: true,
    },
    build: { 
        manifest: true,
        cssTarget: 'chrome112',
        esbuild: {
            target: 'es2022'
        },
        rollupOptions: {
            input: {
                main: path.resolve(__dirname, 'main.js'),
                blog: path.resolve(__dirname, 'blog.js'),
                style: path.resolve(__dirname, 'src/style.css'),
            },
            output: {
              entryFileNames: `assets/[name].[hash].js`,
              chunkFileNames: `assets/[name].[hash].js`,
              assetFileNames: assetInfo => {
                const type = assetInfo.name.substr(assetInfo.name.lastIndexOf('.') + 1);
                if (type === 'js' || type === 'css') {
                  return `assets/[name].[hash].[ext]`;
                } else {
                  return `assets/[name].[ext]`;
                }
              }
            }
        }
    }
}
