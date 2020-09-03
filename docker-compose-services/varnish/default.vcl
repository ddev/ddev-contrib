# Simple default VCL.
#
# For a more advanced example see https://github.com/mattiasgeniar/varnish-6.0-configuration-templates

vcl 4.1;

backend default {
  .host = "web";
  .port = "80";
}
