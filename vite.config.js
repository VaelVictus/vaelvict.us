export default {
    // config options
    server: {
        port: 1337
    },
    build: { 
        manifest: true,
        cssTarget: 'chrome112',
        esbuild: {
            target: 'es2022'
        },
        rollupOptions: {
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