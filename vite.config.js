export default {
    // config options
    server: {
        port: 1337
    },
    dev: {
        rollupOptions: {
            output: {
              entryFileNames: `assets/[name]_dev.js`,
              chunkFileNames: `assets/[name]_dev.js`,
              assetFileNames: `assets/[name]_dev.[ext]`
            }
        }
    },
    build: { 
        manifest: true,
        // for later:
        rollupOptions: {
            output: {
              entryFileNames: `assets/[name].js`,
              chunkFileNames: `assets/[name].js`,
              assetFileNames: `assets/[name].[ext]`
            }
        }
    }
}