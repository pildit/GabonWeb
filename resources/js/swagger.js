import SwaggerUI from 'swagger-ui';
import 'swagger-ui/dist/swagger-ui.css';

SwaggerUI({
    dom_id: '#swagger-ui',
    url: process.env.MIX_APP_URL+'/doc/swagger.json'
})
