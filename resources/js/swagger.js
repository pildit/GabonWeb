import SwaggerUI from 'swagger-ui';

SwaggerUI({
    dom_id: '#swagger-ui',
    url: process.env.APP_URL+'/swagger.yml'
})
