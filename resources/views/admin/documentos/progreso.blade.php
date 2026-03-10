<x-app-layout>

<div class="max-w-3xl mx-auto bg-white shadow rounded-xl p-6">

    <h2 class="text-xl font-semibold mb-6">
        📦 Procesando documentos
    </h2>

    <div class="w-full bg-gray-200 rounded-full h-6">
        <div id="barra"
             class="bg-blue-600 h-6 rounded-full text-white text-sm text-center"
             style="width:0%">
            0%
        </div>
    </div>

    <div class="mt-4 text-sm text-gray-600">
        Procesados: <span id="procesados">0</span> /
        <span id="total">{{ $proceso->total_archivos }}</span>
    </div>

</div>

<script>

    let procesoId = {{ $proceso->id }};

    function actualizarProgreso() {

        fetch('/api/proceso/' + procesoId)
        .then(res => res.json())
        .then(data => {

            let porcentaje = Math.round((data.procesados / data.total_archivos) * 100);

            document.getElementById('barra').style.width = porcentaje + '%';
            document.getElementById('barra').innerText = porcentaje + '%';

            document.getElementById('procesados').innerText = data.procesados;

            if (data.estado === 'completado') {

                document.getElementById('barra').classList.remove('bg-blue-600');
                document.getElementById('barra').classList.add('bg-green-600');

                document.getElementById('barra').innerText = '✔ Finalizado';
            }
        });

    }

    setInterval(actualizarProgreso, 2000);

</script>

</x-app-layout>