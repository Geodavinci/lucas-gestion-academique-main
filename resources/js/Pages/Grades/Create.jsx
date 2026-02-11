import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Create({ course, students }) {
    const form = useForm({
        session: 'normal',
        grades: students.map((s) => ({ student_id: s.id, note: '' })),
    });

    return (
        <AuthenticatedLayout>
            <Head title="Saisie des notes" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Saisie des notes</h1>
                        <p className="text-sm text-slate-600">{course.nom} - {course.filiere?.nom}</p>
                    </div>
                    <Link href={route('teacher.dashboard')} className="text-sm text-slate-600">Retour</Link>
                </div>

                <form
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.post(route('grades.store', course.id));
                    }}
                    className="space-y-4"
                >
                    <div className="bg-white rounded border border-slate-200 p-4">
                        <label className="block text-sm font-medium">Session</label>
                        <select className="mt-1 w-full rounded border-slate-300" value={form.data.session} onChange={(e) => form.setData('session', e.target.value)}>
                            <option value="normal">Normal</option>
                            <option value="rattrapage">Rattrapage</option>
                        </select>
                    </div>

                    <div className="bg-white rounded border border-slate-200">
                        <table className="w-full text-sm">
                            <thead className="bg-slate-50 text-slate-600">
                                <tr>
                                    <th className="text-left px-4 py-3">Étudiant</th>
                                    <th className="text-left px-4 py-3">Matricule</th>
                                    <th className="text-left px-4 py-3">Note (/20)</th>
                                </tr>
                            </thead>
                            <tbody>
                                {students.map((s, idx) => (
                                    <tr key={s.id} className="border-t">
                                        <td className="px-4 py-3">{s.nom} {s.prenom}</td>
                                        <td className="px-4 py-3">{s.matricule}</td>
                                        <td className="px-4 py-3">
                                            <input
                                                className="w-32 rounded border-slate-300"
                                                value={form.data.grades[idx].note}
                                                onChange={(e) => {
                                                    const newGrades = [...form.data.grades];
                                                    newGrades[idx].note = e.target.value;
                                                    form.setData('grades', newGrades);
                                                }}
                                            />
                                        </td>
                                    </tr>
                                ))}
                                {students.length === 0 && (
                                    <tr className="border-t">
                                        <td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucun étudiant inscrit.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>

                    <button className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Enregistrer</button>
                </form>
            </div>
        </AuthenticatedLayout>
    );
}
