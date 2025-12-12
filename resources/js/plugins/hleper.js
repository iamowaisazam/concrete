

export const isFile = (value) => {

        
    return value instanceof File;
    
}

export const imageFileToUrl = (image) => {

    if (image instanceof File ) {
        return URL.createObjectURL(image);
    } else {
        return image;
    }
    
}

export const toFormData = (data) => {
  const formData = new FormData();

  const buildFormData = (value, key) => {
    if (value === null || value === undefined) return;

    // File / Blob
    if (value instanceof File || value instanceof Blob) {
      formData.append(key, value);
      return;
    }

    // Array
    if (Array.isArray(value)) {
      value.forEach((v, i) => {
        buildFormData(v, `${key}[${i}]`);
      });
      return;
    }

    // Object
    if (typeof value === "object") {
      Object.keys(value).forEach((k) => {
        buildFormData(value[k], key ? `${key}[${k}]` : k);
      });
      return;
    }

    // Primitive values
    formData.append(key, value);
  };

  buildFormData(data);
  return formData;
};




export default {
    isFile,
    imageFileToUrl,
    toFormData

}