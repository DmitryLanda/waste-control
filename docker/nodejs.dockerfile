FROM node:alpine

RUN yarn global add @vue/cli

#ENTRYPOINT ["yarn", "serve"]
EXPOSE 8080
