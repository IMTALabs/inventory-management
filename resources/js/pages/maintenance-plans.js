import { confirmToast } from "../mixins/toast.js";

class MaintenancePlansScript {
  static initMaintenancePlansScript() {
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
    this.initMaintenancePlansScript();
  }
}

// Initialize when page loads
One.onLoad(() => MaintenancePlansScript.init());
