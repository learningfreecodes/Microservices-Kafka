FROM nginx:1.25.3

EXPOSE 80 443

# STOPSIGNAL SIGQUIT

# RUN chown -R nginx:nginx /var/log/nginx

# USER nginx

CMD ["nginx-debug", "-g", "daemon off;"]