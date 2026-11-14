            </main>

            <!-- Sticky/Clean Footer -->
            <footer class="mt-auto border-t border-slate-200/80 bg-white/70 py-4 px-6 text-center text-xs text-slate-500">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 max-w-7xl mx-auto">
                    <p>&copy; <?= date('Y') ?> <strong>SiSurat</strong> &mdash; Sistem Informasi Manajemen Surat Menyurat.</p>
                    <p class="text-slate-400">Teknologi: PHP 8+ Native &bull; Supabase REST API (PostgREST) &bull; Tailwind CSS</p>
                </div>
            </footer>
        </div>
    </div>

    <!-- JavaScript Helper -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Auto close flash message after 8 seconds (cukup waktu untuk membaca & mengambil screenshot)
        setTimeout(() => {
            const flash = document.getElementById('flash-banner');
            if (flash) {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 400);
            }
        }, 8000);
    </script>
</body>
</html>
