import { confirmToast } from "../mixins/toast.js";

class UsersScript {
  static initUsersScript() {
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
    this.initUsersScript();
  }
}

// Initialize when page loads
One.onLoad(() => UsersScript.init());
