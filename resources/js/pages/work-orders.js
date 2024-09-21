import { confirmToast } from "../mixins/toast.js";

class WorkOrdersScript {
  static initWorkOrdersScript() {
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
    this.initWorkOrdersScript();
  }
}

// Initialize when page loads
One.onLoad(() => WorkOrdersScript.init());
