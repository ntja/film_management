var settings, config, environment;

settings = {
    environments: {
        development: {
            api_url: 'http://127.0.0.1/film_management/api'
        },
        staging: {
            api_url: ''
        },
        production: {
            api_url: ''
        }
    }
};

environment = 'development';

config = settings.environments[environment];

(function($) {
    $(document).ready(function() {
        base_url = $('body').attr('data-base-url');
    });
})(jQuery);
