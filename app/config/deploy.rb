set :application, "dati.alessandria.it"
set :domain, "146.185.162.27"
set :deploy_to, "/var/www/#{application}"
set :app_path, "app"
set :user, "root"

set :shared_files, [app_path + "/config/parameters.yml", web_path + "/.htaccess"]
set :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true

set :writable_dirs, ["app/cache", "app/logs"]
set :webserver_user, "www-data"
set :permission_method, :acl
set :use_set_permissions, true

set :scm, :git
set :repository, "https://github.com/pugalessandria/dati.alessandria.it.git"
set :deploy_via, :remote_cache
set :branch, "dev"

role :web, domain
role :app, domain, :primary => true

set :use_sudo, false
set :keep_releases, 3

