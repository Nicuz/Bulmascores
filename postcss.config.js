module.exports = {
  plugins: [
    require("postcss-simple-vars")({
      silent: true
    }),
    require("cssnano")({
      preset: 'default',
    }),
    require("postcss-import"),
    require("postcss-nested"),
    require("postcss-for"),
    require("postcss-extend")
  ]
};
