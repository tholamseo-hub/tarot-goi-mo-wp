import {readFile,writeFile,mkdir} from 'node:fs/promises';
import {cards,articles} from './dist/data.js';
import {escapeHtml as E} from './dist/core.js';
const base=await readFile('dist/index.html','utf8');
const paths=['boi-tarot','boi-bai-tarot-hom-nay','boi-bai-tarot-chuyen-sau','y-nghia-78-la-bai-tarot','cac-tarot-reader','nhat-ky','huong-dan','gioi-thieu','quyen-rieng-tu'];
for(const c of cards){const dir=`dist/la-bai/${c.id}`;await mkdir(dir,{recursive:true});await writeFile(`${dir}/index.html`,base.replace(/<title>.*?<\/title>/,`<title>${E(c.name)} — ${E(c.vi)} | Tarot Gợi Mở</title>`).replace('<div class="loader">✦ Tarot Gợi Mở</div>',`<article><h1>${E(c.name)} — ${E(c.vi)}</h1><h2>Ý nghĩa xuôi</h2><p>${E(c.upright)}</p><h2>Ý nghĩa ngược</h2><p>${E(c.reversed)}</p></article>`));}
for(const a of articles){paths.push(`huong-dan/${a.slug}`);}
for(const p of paths){await mkdir(`dist/${p}`,{recursive:true});await writeFile(`dist/${p}/index.html`,base);}
await writeFile('dist/404.html',base);
await writeFile('dist/robots.txt','User-agent: *\nAllow: /\n');
console.log(`Built ${cards.length} card pages, ${articles.length} articles, and app routes.`);
