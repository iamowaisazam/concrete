// src/tags/index.js
export default function registerTags(app) {
  const modules = import.meta.glob('./**/*.vue', { eager: true });

  for (const path in modules) {
    const component = modules[path].default;
    const name = component.name || path.split('/').pop().replace('.vue', '');
    app.component(name, component);
  }
}
