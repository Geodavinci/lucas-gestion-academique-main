import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Show({ teacher, soutenances }) {
    return (
        <AuthenticatedLayout>
            <Head title="Détails enseignant" />
            <div className="mx-auto max-w-5xl px-4 py-8">
                <h1 className="text-2xl font-semibold mb-6">{teacher.nom} {teacher.prenom}</h1>

                <div className="bg-white rounded border border-slate-200 p-6 mb-6">
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div><span className="text-slate-500">Email:</span> {teacher.email || '-'}</div>
                        <div><span className="text-slate-500">Téléphone:</span> {teacher.telephone || '-'}</div>
                        <div><span className="text-slate-500">Spécialité:</span> {teacher.specialite}</div>
                    </div>
                </div>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Date</th>
                                <th className="text-left px-4 py-3">Étudiant</th>
                                <th className="text-left px-4 py-3">Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            {soutenances.map((s) => (
                                <tr key={s.id} className="border-t">
                                    <td className="px-4 py-3">{s.date_soutenance}</td>
                                    <td className="px-4 py-3">{s.student?.nom} {s.student?.prenom}</td>
                                    <td className="px-4 py-3">{s.statut}</td>
                                </tr>
                            ))}
                            {soutenances.length === 0 && (
                                <tr className="border-t"><td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucune soutenance.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
