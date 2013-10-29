set :application, "dati.alessandria.it"
set :domain, "146.185.162.27"
set :deploy_to, "/var/www/#{application}"
set :app_path, "app"
set :user, "root"

#set :shared_files, ["app/config/parameters.yml"]
set :shared_children, [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true
set :vendors_mode, "install"

set :scm, :git
set :repository, "https://github.com/pugalessandria/dati.alessandria.it.git"
set :deploy_via, :remote_cache


role :web, domain
role :app, domain, :primary => true

set :use_sudo, false
set :keep_releases, 3

