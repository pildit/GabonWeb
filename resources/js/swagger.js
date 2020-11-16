import SwaggerUI from 'swagger-ui';
SwaggerUI({
    dom_id: '#swagger-ui',
    url: process.env.MIX_APP_URL+'/doc/swagger.json'
})
