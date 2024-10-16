import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
  plugins: [
    laravel({
      input: [
        "resources/sass/main.scss",
        "resources/sass/oneui/themes/amethyst.scss",
        "resources/sass/oneui/themes/city.scss",
        "resources/sass/oneui/themes/flat.scss",
        "resources/sass/oneui/themes/modern.scss",
        "resources/sass/oneui/themes/smooth.scss",
        "resources/js/oneui/app.js",
        "resources/js/app.js",
        "resources/js/pages/datatables.js",
        "resources/js/pages/users.js",
        "resources/js/pages/metrics.js",
        "resources/js/pages/monitor.js",
        "resources/js/pages/maintenance-plans.js",
        "resources/js/pages/maintenance-schedules.js",
        "resources/js/pages/work-orders.js"
      ],
      refresh: true
    })
  ]
});
