{ pkgs, ... }: {

  # Which nixpkgs channel to use.
  channel = "stable-23.11"; # or "unstable"

  # Use https://search.nixos.org/packages to find packages
  packages = [
    pkgs.nodejs_20
    pkgs.php83
  ];

  services.mysql = {
    enable = true;
    package = pkgs.mysql80;
  };

  # Sets environment variables in the workspace
  env = {
    SOME_ENV_VAR = "hello";
  };

  # Search for the extensions you want on https://open-vsx.org/ and use "publisher.id"
  idx.extensions = [
    "bmewburn.vscode-intelephense-client"
    "DEVSENSE.composer-php-vscode"
    "DEVSENSE.intelli-php-vscode"
    "DEVSENSE.phptools-vscode"
    "DEVSENSE.profiler-php-vscode"
  ];

  # Enable previews and customize configuration
  # idx.previews = {
  #   enable = true;
  #   previews = {
  #     web = {
  #       command = [
  #         "npm"
  #         "run"
  #         "dev"
  #         "--"
  #         "--port"
  #         "5173"
  #         "--host"
  #         "0.0.0.0"
  #         # "--disable-host-check"
  #       ];
  #       manager = "web";
  #     };
  #   };
  # };
}
