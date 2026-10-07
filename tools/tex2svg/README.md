# tex2svg

Convierte fórmulas LaTeX a SVG con **MathJax 3.2.2** (entrada TeX, salida SVG con `fontCache: 'none'`) sin navegador ni LaTeX instalado. Lo usa el Generador de exámenes (`App\Services\Examenes\Tex`) para la vista previa y el PDF.

- `dist/tex2svg.cjs`: un solo archivo autocontenido (≈1,7 MB) que corre con **Node 12 o superior** (el servidor tiene Node 12.22 en `/usr/bin/node`). No necesita `npm install` en el servidor.
- `src/tex2svg.js`: fuente. Paquetes TeX: `base, ams, newcommand, configmacros, mhchem, cancel, color, boldsymbol, textmacros, gensymb, upgreek, braket, cases, mathtools, enclose, extpfeil`, más las macros en español `\sen`, `\tg`, `\ctg`, `\arcsen`, `\senh` y `\R`, `\N`, `\Z`, `\Q`, `\C`.

## Uso

```bash
echo '{"items":[{"tex":"\\frac{a}{b}","display":false},{"tex":"\\ce{2H2 + O2 -> 2H2O}"}]}' | node dist/tex2svg.cjs
node dist/tex2svg.cjs --version
```

Respuesta: `{"version":"3.2.2","items":[{"svg":"<svg…>","w":1.2,"h":2.4,"va":-0.6,"error":null}, …]}` con ancho, alto y `vertical-align` en `ex`. Una fórmula con error de TeX devuelve `svg: null` y el mensaje en `error` (PHP muestra entonces el texto original).

PHP lo llama una vez por documento con todas las fórmulas que no estén en `storage/cache/tex/` (caché por hash). La ruta de Node se toma de `NODE_BINARY` en `.env` o de `/usr/bin/node`, `/usr/local/bin/node` o `C:\Program Files\nodejs\node.exe`.

## Cómo se compiló

Con Node 24 en una carpeta temporal (no hace falta en el servidor):

```bash
cd tools/tex2svg
npm install          # instala esbuild 0.28.2 y mathjax-full 3.2.2 (node_modules/ está en .gitignore)
npm run build        # esbuild --bundle --platform=node --target=node12 --format=cjs --minify --legal-comments=eof
```

Se verificó con Node 12.22.12 en el servidor de producción (salida idéntica a la de Node 24; ≈0,45 s para 9 fórmulas, incluido el arranque).

## dompdf

`php-svg-lib` no entiende las unidades `ex` ni escala el `viewBox` si el SVG trae `width`/`height`. Por eso, para el PDF, `Tex::mathHtml()` quita `width`, `height` y `style` del SVG y lo inserta como `<img>` con `width`, `height` y `vertical-align` en `em` (1 ex de MathJax = 0,5 em). El servidor no tiene delegado SVG en Imagick, así que no se rasteriza.

Licencia: MathJax y mhchemParser son Apache-2.0 (los avisos van al final de `dist/tex2svg.cjs`).
