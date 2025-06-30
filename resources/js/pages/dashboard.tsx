import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';
import React from 'react';

// --- TYPE DEFINITIONS (for data passed from Laravel) ---
interface Ticket {
    id: number;
    title: string;
    status: 'pending' | 'in_progress' | 'completed';
    priority: 'low' | 'medium' | 'high';
    user?: { name: string }; // User who created the ticket
    updated_at: string; // Will be a string date
    created_at: string;
}

interface DashboardProps {
    employeeData?: {
        recent_tickets: Ticket[];
        open_tickets_count: number;
        resolved_tickets_count: number;
    };
    supportData?: {
        new_tickets: Ticket[];
        assigned_to_me_count: number;
    };
    adminData?: {
        stats: {
            total_users: number;
            total_open_tickets: number;
            total_assets: number;
        };
        quick_actions: { name: string; href: string; icon: string }[];
    };
}

// --- UI COMPONENTS ---

const WelcomeBanner: React.FC<{ name: string }> = ({ name }) => (
    <div className="mb-8 px-6 py-5 bg-white dark:bg-gray-800 shadow-md sm:rounded-lg border-l-4 border-blue-600 dark:border-blue-500">
        <h1 className="text-2xl md:text-3xl font-bold text-gray-900 dark:text-gray-100">
            خوش آمدید، {name}!
        </h1>
        <p className="text-gray-600 dark:text-gray-400 mt-1">
            در اینجا خلاصه‌ای از فعالیت‌ها و وظایف شما آمده است.
        </p>
    </div>
);

const StatusBadge: React.FC<{ status: Ticket['status'] }> = ({ status }) => {
    const statusClasses = {
        pending: 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
        in_progress: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
        completed: 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
    };
    const statusText = {
        pending: 'در انتظار',
        in_progress: 'در حال انجام',
        completed: 'تکمیل شده',
    };
    return <span className={`px-3 py-1 text-xs font-medium rounded-full ${statusClasses[status]}`}>{statusText[status]}</span>;
};

const PriorityIndicator: React.FC<{ priority: Ticket['priority'] }> = ({ priority }) => {
    const priorityClasses = {
        high: 'text-red-500',
        medium: 'text-yellow-500',
        low: 'text-green-500',
    };
    const priorityText = {
        high: 'زیاد',
        medium: 'متوسط',
        low: 'کم',
    };
    return <span className={`${priorityClasses[priority]} font-semibold`}><i className="fas fa-flag mr-1"></i> {priorityText[priority]}</span>;
};

const DashboardCard: React.FC<{ title: string; icon: string; link?: string; linkText?: string; children: React.ReactNode }> = ({ title, icon, link, linkText, children }) => (
    <div className="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
        <div className="p-5 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 className="text-lg font-semibold text-gray-800 dark:text-gray-100">
                <i className={`fas ${icon} text-gray-400 dark:text-gray-500 ml-3`}></i>{title}
            </h3>
            {link && <Link href={link} className="text-sm font-medium text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"> {linkText || 'مشاهده همه'} </Link>}
        </div>
        <div className="p-0">{children}</div>
    </div>
);

// --- ROLE-SPECIFIC DASHBOARD VIEWS ---

const EmployeeDashboard: React.FC<{ data: DashboardProps['employeeData'] }> = ({ data }) => (
    <div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div className="dashboard-card p-6 flex items-center justify-between">
                <div>
                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400">درخواست‌های باز</p>
                    <p className="text-3xl font-bold text-gray-900 dark:text-gray-100">{data?.open_tickets_count ?? 0}</p>
                </div>
                <i className="fas fa-folder-open text-4xl text-yellow-400"></i>
            </div>
             <div className="dashboard-card p-6 flex items-center justify-between">
                <div>
                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400">درخواست‌های حل شده</p>
                    <p className="text-3xl font-bold text-gray-900 dark:text-gray-100">{data?.resolved_tickets_count ?? 0}</p>
                </div>
                <i className="fas fa-check-circle text-4xl text-green-400"></i>
            </div>
        </div>

        <DashboardCard title="آخرین درخواست‌های شما" icon="fa-history" link="/tickets/my">
             <div className="overflow-x-auto">
                <table className="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" className="px-6 py-3">عنوان</th>
                            <th scope="col" className="px-6 py-3">وضعیت</th>
                            <th scope="col" className="px-6 py-3">آخرین بروزرسانی</th>
                            <th scope="col" className="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {data?.recent_tickets && data.recent_tickets.length > 0 ? (
                            data.recent_tickets.map((ticket) => (
                                <tr key={ticket.id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{ticket.title}</th>
                                    <td className="px-6 py-4"><StatusBadge status={ticket.status} /></td>
                                    <td className="px-6 py-4">{new Date(ticket.updated_at).toLocaleDateString('fa-IR')}</td>
                                    <td className="px-6 py-4 text-left"><Link href={`/tickets/${ticket.id}`} className="font-medium text-blue-600 dark:text-blue-500 hover:underline">مشاهده</Link></td>
                                </tr>
                            ))
                        ) : (
                            <tr><td colSpan={4} className="text-center py-10 text-gray-500">شما تاکنون درخواستی ثبت نکرده‌اید.</td></tr>
                        )}
                    </tbody>
                </table>
            </div>
        </DashboardCard>
    </div>
);

const SupportDashboard: React.FC<{ data: DashboardProps['supportData'] }> = ({ data }) => (
     <div>
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
             <div className="dashboard-card p-6 flex items-center justify-between bg-red-500 text-white">
                <div>
                    <p className="text-sm font-medium opacity-80">درخواست‌های جدید در انتظار</p>
                    <p className="text-3xl font-bold">{data?.new_tickets?.length ?? 0}</p>
                </div>
                <i className="fas fa-inbox text-4xl opacity-70"></i>
            </div>
            <div className="dashboard-card p-6 flex items-center justify-between bg-blue-500 text-white">
                <div>
                    <p className="text-sm font-medium opacity-80">درخواست‌های ارجاع شده به من</p>
                    <p className="text-3xl font-bold">{data?.assigned_to_me_count ?? 0}</p>
                </div>
                 <i className="fas fa-user-tag text-4xl opacity-70"></i>
            </div>
        </div>

        <DashboardCard title="صندوق ورودی درخواست‌ها" icon="fa-inbox" link="/tickets/all?status=pending">
            <div className="overflow-x-auto">
                <table className="w-full text-sm text-right text-gray-500 dark:text-gray-400">
                    <thead className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" className="px-6 py-3">عنوان</th>
                            <th scope="col" className="px-6 py-3">کاربر</th>
                            <th scope="col" className="px-6 py-3">اولویت</th>
                            <th scope="col" className="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody>
                         {data?.new_tickets && data.new_tickets.length > 0 ? (
                            data.new_tickets.map((ticket) => (
                                <tr key={ticket.id} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <th scope="row" className="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{ticket.title}</th>
                                    <td className="px-6 py-4">{ticket.user?.name ?? 'N/A'}</td>
                                    <td className="px-6 py-4"><PriorityIndicator priority={ticket.priority} /></td>
                                    <td className="px-6 py-4 text-left"><Link href={`/tickets/${ticket.id}`} className="font-medium text-blue-600 dark:text-blue-500 hover:underline">بررسی</Link></td>
                                </tr>
                            ))
                        ) : (
                             <tr><td colSpan={4} className="text-center py-10 text-gray-500">درخواست جدیدی برای بررسی وجود ندارد.</td></tr>
                        )}
                    </tbody>
                </table>
            </div>
        </DashboardCard>
    </div>
);

const AdminDashboard: React.FC<{ data: DashboardProps['adminData'] }> = ({ data }) => (
    <div>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div className="dashboard-card p-6 flex items-center">
                <i className="fas fa-users text-3xl text-purple-500 ml-5"></i>
                <div>
                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400">کل کاربران</p>
                    <p className="text-3xl font-bold text-gray-800 dark:text-gray-100">{data?.stats?.total_users ?? 0}</p>
                </div>
            </div>
            <div className="dashboard-card p-6 flex items-center">
                <i className="fas fa-folder-open text-3xl text-red-500 ml-5"></i>
                <div>
                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400">درخواست‌های باز</p>
                    <p className="text-3xl font-bold text-gray-800 dark:text-gray-100">{data?.stats?.total_open_tickets ?? 0}</p>
                </div>
            </div>
            <div className="dashboard-card p-6 flex items-center">
                <i className="fas fa-microchip text-3xl text-blue-500 ml-5"></i>
                <div>
                    <p className="text-sm font-medium text-gray-500 dark:text-gray-400">کل قطعات</p>
                    <p className="text-3xl font-bold text-gray-800 dark:text-gray-100">{data?.stats?.total_assets ?? 0}</p>
                </div>
            </div>
        </div>

        <DashboardCard title="دسترسی سریع مدیریت" icon="fa-cogs">
            <div className="p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                {data?.quick_actions?.map(action => (
                     <Link key={action.href} href={action.href} className="flex flex-col items-center justify-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors duration-200">
                        <i className={`fas ${action.icon} text-2xl text-blue-600 dark:text-blue-400 mb-2`}></i>
                        <span className="text-sm font-semibold text-gray-700 dark:text-gray-200">{action.name}</span>
                    </Link>
                ))}
            </div>
        </DashboardCard>
    </div>
);


// --- MAIN DASHBOARD COMPONENT ---
export default function Dashboard({ employeeData, supportData, adminData }: DashboardProps) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    const renderDashboardByRole = () => {
        switch (user?.role) {
            case 'user':
                return <EmployeeDashboard data={employeeData} />;
            case 'support':
                return <SupportDashboard data={supportData} />;
            case 'admin':
                return <AdminDashboard data={adminData} />;
            default:
                return <div className="text-center text-red-500 p-10">نقش کاربری شما تعریف نشده است و یا مشکلی در دریافت اطلاعات رخ داده است.</div>;
        }
    };

    return (
        <AppLayout breadcrumbs={[{ title: 'داشبورد', href: route('dashboard') }]}>
            <Head title="داشبورد" />
            <div className="py-8" dir="rtl">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <WelcomeBanner name={user?.name ?? 'کاربر'} />
                    {renderDashboardByRole()}
                </div>
            </div>
        </AppLayout>
    );
}