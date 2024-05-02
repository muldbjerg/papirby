/**
  * @title: Gulp for XAMPP
  * @description: Gulp.js configuration for WordPress development with XAMPP
  * @author: Daniel Cassman
  * @website: https://danielcassman.com
  */
'use strict';

const
  wordpress_project_name = 'silkeborg',
  theme_name = 'papirby',
  browserSyncProxy = `http://localhost/${wordpress_project_name}/`,
  dir = {
    src         : 'src/',
    build       : `../../../../../htdocs/${wordpress_project_name}/wp-content/themes/${theme_name}/`
  };

  import gulp from "gulp";
  const { src, dest, series, watch } = gulp;
  import gulpSass from "gulp-sass";
  import deporder from "gulp-deporder";
  import concat from "gulp-concat";   // Not necessary if you don't want to combine files; see line 121
  import stripdebug from "gulp-strip-debug";
  import uglify from "gulp-uglify";
  import browserSync from 'browser-sync';
  import autoprefixer from "autoprefixer";
  import cssnano from "cssnano";
  import * as dartSass from 'sass';
  import cleanCss from "gulp-clean-css";

// Image settings, assumes images are stored in the /img directory in the theme folder
// const images = {
//   src         : dir.src + 'img/**/*',
//   exclude     : [`!${dir.src}img/*.psd`, `!${dir.src}img/*.xcf`],
//   build       : dir.build + 'img/'
// };
// image processing
// gulp.task('images', async () => {
//   let rules = [ images.src ];
//   rules = rules.concat(images.exclude);
//   return src(rules)
//     .pipe(newer(images.build))
//     .pipe(imagemin())
//     .pipe(dest(images.build));
// });

// CSS settings
const sass = gulpSass(dartSass);

const css = {
  src         : dir.src + 'scss/main.scss',
  watch       : dir.src + 'scss/**/*',
  build       : dir.build,
  sassOpts: {
    outputStyle     : 'compressed',
    precision       : 3,
    errLogToConsole : true
  },
  devOpts: {
    outputStyle     : 'expanded',
    precision       : 3,
    errLogToConsole : true
  },
  processors: [
    autoprefixer(),
    cssnano()
  ]
};

// CSS processing
function processPrimarySass( dev = false ) {
  return src(css.src)
    .pipe(sass(dev ? css.devOpts : css.sassOpts))
    .pipe(cleanCss())
    .pipe(dest(`${css.build}`))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());
}

function processOtherSass( dev = false ) {
  return src([css.watch, `!${css.src}`])
    .pipe(sass(dev ? css.devOpts : css.sassOpts))
    .pipe(dest(`${css.build}css`))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());
}

async function processSass(dev = false) {
  processPrimarySass(dev);
  processOtherSass(dev);
}

gulp.task('css', async() => {
  processSass(false)
});
gulp.task('cssdev', async () => {
  processSass(true);
});

// JavaScript settings
const js = {
  src         : dir.src + 'js/**/*',
  build       : dir.build + 'js/',
  filename    : 'scripts.js'
};

function processJs( dev = false ) {
  let jsOutput = gulp.src(js.src)
    .pipe(deporder())
//  .pipe(concat(js.filename))  Uncomment this line if you want to combine Javascript files
    
  if( !dev ) {
    jsOutput = jsOutput.pipe(stripdebug())
    .pipe(uglify());
  }
    
  jsOutput = jsOutput.pipe(gulp.dest(js.build))
    .pipe(browsersync ? browsersync.reload({ stream: true }) : gutil.noop());
  return jsOutput;
}

// JavaScript processing
gulp.task('js', async () => {
  processJs(false);
});
gulp.task('jsdev', async () => {
  processJs(true);
});

// Run all tasks
// gulp.task('build', series('images', 'css', 'js'));
gulp.task('build', series( 'css', 'js'));

// Browsersync options
let browsersync = browserSync.create();
const reload = (cb) => {
  browserSync.reload();
  if(typeof cb === 'function') cb();
};

const syncOpts = {
  proxy       : browserSyncProxy,
  files       : dir.build + '**/*',
  open        : false,
  notify      : false,
  ghostMode   : false,
  ui: {
    port: 8001
  }
};

const filesToWatch = [
  "*.php"
];

// Basic file changes to trigger browser reload
gulp.task('browsersync', async () => {
  if( browsersync === false )
    browsersync = browserSync.create();
  browsersync.init(syncOpts);
  browsersync.watch(filesToWatch).on("change", reload);
});

// Files where changes should trigger a compile + reload
gulp.task('watch', series('browsersync', async () => {

  // image changes
  // watch(images.src, series('images'));

  // CSS changes
  watch(css.watch, series('css', reload));

  // JavaScript main changes
  watch(js.src, series('js', reload));
}));

gulp.task('watchdev', series('browsersync', async () => {

  // image changes
  // watch(images.src, series('images'));

  // CSS changes
  watch(css.watch, series('cssdev', reload));

  // JavaScript main changes
  watch(js.src, series('jsdev', reload));
}));

// Build site and start watching
gulp.task('test', series('build', 'watch'));
// gulp.task('develop', series('images', 'cssdev', 'jsdev', 'watchdev'));
gulp.task('develop', series( 'cssdev', 'jsdev', 'watchdev'));
