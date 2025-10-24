<template>
    <div class="app" :class="[currentTheme, { loading: loading }]">
        <!-- Header Cyberpunk -->
        <header class="cyber-header">
            <div class="header-glitch" data-text="BUSCADOR DE REGISTROS">
                BUSCADOR DE REGISTROS
            </div>
            <div class="theme-controls">
                <!-- Selector de Temas -->
                <div class="theme-selector">
                    <select
                        class="cyber-select"
                        v-model="selectedTheme"
                        @change="changeTheme"
                    >
                        <option value="theme-cyberpunk">
                            🔮 Cyberpunk 2077
                        </option>
                        <!-- Nombre actualizado -->
                        <option value="theme-matrix">💚 Matrix</option>
                        <option value="theme-neon">💜 Neon</option>
                        <option value="theme-gruvbox-dark">
                            🌙 Gruvbox Dark
                        </option>
                        <option value="theme-gruvbox-light">
                            ☀️ Gruvbox Light
                        </option>
                        <option value="theme-profesional">
                            💼 Profesional
                        </option>
                        <option value="theme-profesional-minimal">
                            ⚡ Profesional Minimal
                        </option>

                        <option value="theme-ultra-profesional">
                            🏢 Ultra Profesional
                        </option>
                    </select>
                </div>
            </div>
        </header>

        <div class="cyber-grid">
            <!-- Panel izquierdo - Controles -->
            <div class="cyber-panel control-panel">
                <!-- Barra de búsqueda -->
                <div class="cyber-section">
                    <label class="cyber-label">TERMINAL DE BÚSQUEDA</label>
                    <SearchBar
                        :modelValue="query"
                        :loading="loading"
                        @update:modelValue="(val) => (query = val)"
                        @search="searchNow"
                        @live="handleLive"
                    />
                </div>

                <!-- Stats y Configuración -->
                <div class="cyber-stats">
                    <div class="stat-item">
                        <div class="stat-value">{{ total }}</div>
                        <div class="stat-label">REGISTROS TOTALES</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ rows.length }}</div>
                        <div class="stat-label">RESULTADOS</div>
                    </div>
                </div>

                <!-- Configuración -->
                <div class="cyber-section">
                    <label class="cyber-label">CONFIGURACIÓN</label>
                    <div class="config-row">
                        <span>Resultados/página:</span>
                        <select
                            class="cyber-select"
                            v-model.number="pageSize"
                            @change="searchNow"
                        >
                            <option :value="10">10</option>
                            <option :value="20">20</option>
                            <option :value="50">50</option>
                            <option :value="100">100</option>
                        </select>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="cyber-section">
                    <label class="cyber-label">ACCIONES</label>
                    <div class="action-grid">
                        <ExportButton :rows="rows" class="cyber-export" />
                        <button
                            class="cyber-button secondary"
                            @click="limpiarFiltros"
                            :disabled="loading"
                        >
                            <span class="btn-glitch" data-text="LIMPIAR"
                                >LIMPIAR</span
                            >
                        </button>
                    </div>
                </div>
            </div>

            <!-- Panel derecho - Resultados -->
            <div class="cyber-panel results-panel">
                <!-- Header de resultados -->
                <div class="results-header">
                    <h3 class="cyber-title">RESULTADOS DEL SISTEMA</h3>
                    <div class="pagination-info">
                        <span class="cyber-text"
                            >PÁGINA {{ page }} DE {{ totalPages }}</span
                        >
                    </div>
                </div>

                <!-- Tabla de resultados -->
                <div class="table-container">
                    <ResultsTableEmpresas
                        :rows="rows"
                        :loading="loading"
                        :error="error"
                    />
                </div>

                <!-- Paginación -->
                <div class="cyber-pagination">
                    <button
                        class="cyber-button pagination-btn"
                        :disabled="page === 1 || loading"
                        @click="changePage(page - 1)"
                    >
                        ‹ ANTERIOR
                    </button>
                    <div class="page-indicator">
                        <span class="current-page">{{ page }}</span>
                        <span class="page-separator">/</span>
                        <span class="total-pages">{{ totalPages }}</span>
                    </div>
                    <button
                        class="cyber-button pagination-btn"
                        :disabled="page === totalPages || loading"
                        @click="changePage(page + 1)"
                    >
                        SIGUIENTE ›
                    </button>
                </div>

                <!-- Estado vacío -->
                <div v-if="!loading && rows.length === 0" class="cyber-empty">
                    <div class="empty-icon">⚡</div>
                    <h3>SISTEMA: SIN RESULTADOS</h3>
                    <p v-if="query">
                        Búsqueda: "<strong>{{ query }}</strong
                        >" no coincide con ningún registro
                    </p>
                    <p v-else>Base de datos vacía o sin conexión</p>
                </div>
            </div>
        </div>

        <!-- Loading Overlay -->
        <div v-if="loading" class="cyber-loading">
            <div class="loading-spinner"></div>
            <div class="loading-text">ESCANEANDO BASE DE DATOS...</div>
        </div>
    </div>
</template>

<script>
import debounce from "./utils/debounce";
import { empresasService } from "./services/api";
import SearchBar from "./components/SearchBar.vue";
import ResultsTableEmpresas from "./components/ResultsTableEmpresas.vue";
import ExportButton from "./components/ExportButton.vue";

export default {
    name: "App",
    components: { SearchBar, ResultsTableEmpresas, ExportButton },
    data() {
        return {
            query: "",
            page: 1,
            pageSize: 20,
            total: 0,
            rows: [],
            loading: false,
            error: "",
            selectedTheme: "theme-cyberpunk",
            isDark: true,
        };
    },
    computed: {
        totalPages() {
            return Math.max(1, Math.ceil(this.total / this.pageSize));
        },
        currentTheme() {
            return this.selectedTheme;
        },
    },
    created() {
        this.loadTheme();
        this.searchNow();
    },
    methods: {
        async fetchResults() {
            this.loading = true;
            this.error = "";
            try {
                const params = {
                    q: this.query,
                    page: this.page,
                    limit: this.pageSize,
                };

                const { data } = await empresasService.buscar(params);

                if (data?.ok) {
                    this.rows = data.rows || [];
                    this.total = data.total || 0;
                } else {
                    this.rows = [];
                    this.total = 0;
                    this.error = "ERROR: Formato de respuesta inválido";
                }
            } catch (err) {
                console.error("Error:", err);
                this.error =
                    "ERROR: " +
                    (err.message || "Falló la conexión con el servidor");
                this.rows = [];
                this.total = 0;
            } finally {
                this.loading = false;
            }
        },

        searchNow() {
            this.page = 1;
            this.fetchResults();
        },

        changePage(newPage) {
            if (newPage === this.page) return;
            this.page = newPage;
            this.fetchResults();
        },

        limpiarFiltros() {
            this.query = "";
            this.page = 1;
            this.fetchResults();
        },

        handleLive: debounce(function (val) {
            this.query = val;
            this.page = 1;
            this.fetchResults();
        }, 400),

        changeTheme() {
            // Determinar si el tema es oscuro basado en el tema seleccionado
            this.isDark = !this.selectedTheme.includes("light");
            localStorage.setItem("selectedTheme", this.selectedTheme);
            localStorage.setItem("isDark", this.isDark.toString());
        },

        toggleDarkMode() {
            this.isDark = !this.isDark;

            // Cambiar entre temas claros/oscuros manteniendo el estilo
            if (this.isDark) {
                if (this.selectedTheme === "theme-gruvbox-light") {
                    this.selectedTheme = "theme-gruvbox-dark";
                } else if (
                    !this.selectedTheme.includes("dark") &&
                    !this.selectedTheme.includes("cyberpunk") &&
                    !this.selectedTheme.includes("matrix") &&
                    !this.selectedTheme.includes("neon")
                ) {
                    this.selectedTheme = "theme-cyberpunk";
                }
            } else {
                if (this.selectedTheme === "theme-gruvbox-dark") {
                    this.selectedTheme = "theme-gruvbox-light";
                } else if (
                    this.selectedTheme.includes("dark") ||
                    this.selectedTheme.includes("cyberpunk") ||
                    this.selectedTheme.includes("matrix") ||
                    this.selectedTheme.includes("neon")
                ) {
                    this.selectedTheme = "theme-profesional";
                }
            }

            localStorage.setItem("selectedTheme", this.selectedTheme);
            localStorage.setItem("isDark", this.isDark.toString());
        },

        loadTheme() {
            const savedTheme = localStorage.getItem("selectedTheme");
            const savedDarkMode = localStorage.getItem("isDark");

            if (savedTheme) {
                this.selectedTheme = savedTheme;
            }

            if (savedDarkMode !== null) {
                this.isDark = savedDarkMode === "true";
            }
        },
    },
};
</script>

<style scoped>
/* Estilos específicos del componente */
</style>
