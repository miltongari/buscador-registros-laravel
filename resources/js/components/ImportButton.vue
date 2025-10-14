<template>
  <div>
    <input type="file" ref="fileInput" accept=".xlsx" style="display: none" @change="handleFile" />
    <button class="btn success" @click="triggerInput">
      ⬆️ Importar Excel
    </button>
  </div>
</template>

<script>
import * as XLSX from "xlsx";

export default {
  name: "ImportButton",
  emits: ["imported"],
  methods: {
    triggerInput() {
      this.$refs.fileInput.click();
    },
    handleFile(e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (event) => {
        try {
          const data = new Uint8Array(event.target.result);
          const workbook = XLSX.read(data, { type: "array" });
          const sheetName = workbook.SheetNames[0];
          const worksheet = workbook.Sheets[sheetName];
          const json = XLSX.utils.sheet_to_json(worksheet);

          this.$emit("imported", json);
          alert("Archivo importado correctamente ✅");
        } catch (err) {
          console.error("Error importando Excel:", err);
          alert("Error al importar el archivo Excel.");
        }
      };
      reader.readAsArrayBuffer(file);
    },
  },
};
</script>

<style scoped>
.btn.success {
  background-color: #28a745;
  color: white;
}
.btn.success:hover {
  background-color: #218838;
}
</style>
