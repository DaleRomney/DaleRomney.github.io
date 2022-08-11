
using Boggle.Models;
using Microsoft.EntityFrameworkCore;
using Microsoft.Azure.SignalR;
using Microsoft.AspNetCore.Builder;
using Boggle.Hubs;

var builder = WebApplication.CreateBuilder(args);

// Add services to the container.
builder.Services.AddScoped<User>();
builder.Services.AddSingleton<Board>();
builder.Services.AddRazorPages();
builder.Services.AddServerSideBlazor();
builder.Services.AddDbContextFactory<sliceofbreadContext>(options =>
options.UseSqlServer(builder.Configuration.GetConnectionString("db"))
);
builder.Services.AddSignalR();
if (!builder.Environment.IsDevelopment())
{
    builder.Services.AddSignalR(x => x.EnableDetailedErrors = true)
    .AddAzureSignalR(builder.Configuration.GetConnectionString("signalR"));
}


var app = builder.Build();

// Configure the HTTP request pipeline.
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Error");
    // The default HSTS value is 30 days. You may want to change this for production scenarios, see https://aka.ms/aspnetcore-hsts.
    app.UseHsts();
}
app.UseHttpsRedirection();
app.UseWebSockets();
app.UseStaticFiles();
app.UseRouting();
app.MapBlazorHub();
app.MapHub<BoggleHub>("/BoggleHub");
app.MapFallbackToPage("/_Host");

app.Run();
