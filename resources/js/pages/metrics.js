class MetricsScript {
  static initMetricsScript() {
    jQuery(".btn-add-metric").on("click", function () {
      jQuery(".list-metrics").append(`
        <div class="col-7">
            <input type="text" class="form-control form-control-alt" name="name[]" placeholder="Name">
        </div>
        <div class="col-4">
            <input type="text" class="form-control form-control-alt" name="unit[]" placeholder="Unit">
        </div>
        <div class="col-1">
            <button type="button" class="btn-remove-metric btn w-100 text-danger">
                <i class="fa fa-xl fa-circle-xmark"></i>
            </button>
        </div>
      `);
    });

    jQuery(".list-metrics").on("click", ".btn-remove-metric", function () {
      jQuery(this).parent().prev().prev().remove();
      jQuery(this).parent().prev().remove();
      jQuery(this).parent().remove();
    });
  }

  /*
   * Init functionality
   *
   */
  static init() {
    this.initMetricsScript();
  }
}

// Initialize when page loads
One.onLoad(() => MetricsScript.init());
