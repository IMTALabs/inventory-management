export const confirmToast = Swal.mixin({
  buttonsStyling: false,
  target: '#page-container',
  customClass: {
    confirmButton: 'btn btn-danger m-1',
    cancelButton: 'btn btn-secondary m-1',
    input: 'form-control'
  },
  title: 'Are you sure?',
  text: 'You will not be able to undo this operation.',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonText: 'Yes, do it!',
  html: false,
});

export const successToast = Swal.mixin({
  buttonsStyling: false,
  target: '#page-container',
  customClass: {
    confirmButton: 'btn btn-primary m-1',
  },
  icon: 'success',
  showCancelButton: false,
  confirmButtonText: 'OK',
  html: false,
});
