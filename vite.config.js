export default {
    // config options
    server: {
        port: 1337
    },
    build: { 
        manifest: true,
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