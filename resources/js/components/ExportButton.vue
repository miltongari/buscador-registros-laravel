<template>
  <button
    class="cyber-button"
    @click="exportExcel"
    :disabled="!rows?.length"
    title="Exportar resultados a Excel"
  >
    <span class="btn-glitch" data-text="EXPORTAR">EXPORTAR</span>
  </button>
</template>

<script>
import * as XLSX from "xlsx";

export default {
  name: "ExportButton",
  props: {
    rows: { type: Array, default: () => [] },
    filename: { type: String, default: '' }
  },
  methods: {
    exportExcel() {
      if (!this.rows.length) {
        alert("No hay datos para exportar");
        return;
      }

      try {
        const normalized = this.rows.map((r) => ({
          ID: r.id,
          "Razón social": r.razon_social || "",
          Municipio: r.municipio || "",
          Departamento: r.departamento || "",
          Actividades: Array.isArray(r.actividades)
            ? r.actividades.map((a) => a.nombre).join(", ")
            : r.actividades || "",
          Dirección: r.direccion || "",
          "Fecha matrícula": r.fecha_matricula
            ? new Date(r.fecha_matricula).toLocaleDateString()
            : "",
          "Representante legal": r.rep_legal || "",
        }));

        const ws = XLSX.utils.json_to_sheet(normalized);
        const columnWidths = Object.keys(normalized[0] || {}).map(() => ({ wch: 20 }));
        ws["!cols"] = columnWidths;

        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Empresas");

        const fecha = new Date();
        const timestamp = fecha.toISOString().split("T")[0];
        const fileName = this.filename || `empresas_${timestamp}.xlsx`;

        XLSX.writeFile(wb, fileName);
      } catch (err) {
        console.error("Error exportando Excel:", err);
        this.$emit("error", err);
        alert("Hubo un problema al exportar el archivo Excel.");
      }
    },
  },
};
</script>

<style scoped>
.cyber-export {
  width: 100%;
}
</style>