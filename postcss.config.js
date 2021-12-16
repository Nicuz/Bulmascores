module.exports = {
  plugins: [
    require("postcss-simple-vars")({
      silent: true
    }),
    /*require("cssnano")({
      autoprefixer: false
    }),*/
    require("autoprefixer")({
      "browsers": [
        "last 2 versions"
      ]
    }),
    require("postcss-import"),
    require("postcss-nested"),
    require("postcss-for"),
    require("postcss-extend")
  ]
};
