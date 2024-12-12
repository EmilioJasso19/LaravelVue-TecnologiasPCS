<script>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

export default{
    components: {
    AppLayout,
    InputLabel,
    TextInput,
    InputError,
    PrimaryButton
  },
  data() {
    return {
      loading: false,
      error: null,
    };
  },
  props: {
    auth: Object,
    group: Object,
  },
  setup(props) {
    const form = useForm({
        educationalExperienceId: props.group.educationalExperienceId,
        name: props.group.name,
        shift: props.group.shift,
        period: props.group.period,
    });

    const shifts = [
      { value: 'Matutino', label: 'MATUTINO' },
      { value: 'Vespertino', label: 'VESPERTINO' },
    ];

    const submit = () => {
    form.transform((data) => ({
        ...data,
        educational_experience_id: data.educationalExperienceId // Cambia el nombre
    })).patch(route('groups.update', {group: props.group.id}), {
        onFinish: () => {
            form.reset();
            window.location.href = route('groups.show', {group: props.group.id})
        },
        onError: (errors) => {
            console.error('Errores de validación:', errors);
        }
    });
};

    return {
      form,
      shifts,
      submit,
    };
  }
}
</script>

<template>
    <AppLayout>
        <template #header>
            Editar grupo
        </template>

        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white border-b border-gray-200 flex justify-between">
                    <h3 class="text-2xl font-medium text-gray-900">
                        Editar grupo
                    </h3>
                </div>
        <form @submit.prevent="submit" class="py-12 px-64 flex flex-col">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="shift" value="Turno" />
                <select id="shift" v-model="form.shift" class="mt-1 block w-full">
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option v-for="(shift, index) in shifts" :key="index" :value="shift.value">
                        {{ shift.label }}
                    </option>
                </select>
                <InputError class="mt-2" :message="form.errors.program" />
            </div>

            <div class="mt-4">
                <InputLabel for="period" value="Periodo" />
                <TextInput
                    id="period"
                    v-model="form.period"
                    type="text"
                    class="mt-1 block w-full"
                    required
                />
                <InputError class="mt-2" :message="form.errors.nrc" />
            </div>

            <div class="flex items-center justify-center mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="submit"
                >
                    Guardar
                </PrimaryButton>
                </div>
                </form>
            </div>
        </div>
    </div>
</AppLayout>
</template>
