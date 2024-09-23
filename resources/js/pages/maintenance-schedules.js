import { confirmToast } from "../mixins/toast.js";

class MaintenanceSchedulesScript {
  static initMaintenanceSchedulesScript() {
    jQuery(".form-delete").on("submit", function (e) {
      e.preventDefault();
      confirmToast.fire({}).then(result => {
        if (result.value) {
          e.target.submit();
        }
      });
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initMaintenanceSchedulesScript();
  }
}

// Initialize when page loads
One.onLoad(() => MaintenanceSchedulesScript.init());
