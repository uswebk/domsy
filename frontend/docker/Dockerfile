FROM node:16.13.2-alpine

EXPOSE 8080
ENV HOST 0.0.0.0

RUN apk update && \
    apk add git && \
    npm install -g @vue/cli nuxt create-nuxt-app
