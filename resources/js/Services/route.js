export function replaceRoute(string, values) {
  return string.replace(/{(.*?)}/g, (match, offset) =>
    values.hasOwnProperty(offset) ? values[offset] : "UNDEFINED"
  );
}
