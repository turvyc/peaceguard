//
//  MainViewController.m
//  peaceguard
//
//  Created by Robert Sanchez on 2013-03-12.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "MainViewController.h"

#import "ReportViewController.h"
#import "StatisticsViewController.h"


@interface MainViewController ()

@end

@implementation MainViewController

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    NSUserDefaults *defaults = [NSUserDefaults standardUserDefaults];
    NSString *username = [defaults objectForKey:@"username"];
    self.usernameData = username;
    //NSLog(self.usernameData);
    
    self.mainBackground.animationImages = [NSArray arrayWithObjects:[UIImage imageNamed:@"1.jpg"],[UIImage imageNamed:@"2.jpg"],[UIImage imageNamed:@"3.jpg"],[UIImage imageNamed:@"4.jpg"],[UIImage imageNamed:@"5.jpg"],[UIImage imageNamed:@"6.jpg"],[UIImage imageNamed:@"7.jpg"],[UIImage imageNamed:@"8.jpg"],[UIImage imageNamed:@"9.jpg"],[UIImage imageNamed:@"10.jpg"],[UIImage imageNamed:@"11.jpg"],[UIImage imageNamed:@"12.jpg"], [UIImage imageNamed:@"13.jpg"],[UIImage imageNamed:@"14.jpg"],[UIImage imageNamed:@"15.jpg"],[UIImage imageNamed:@"16.jpg"],[UIImage imageNamed:@"17.jpg"],[UIImage imageNamed:@"18.jpg"],[UIImage imageNamed:@"19.jpg"],[UIImage imageNamed:@"20.jpg"],[UIImage imageNamed:@"21.jpg"],[UIImage imageNamed:@"22.jpg"],[UIImage imageNamed:@"23.jpg"],[UIImage imageNamed:@"24.jpg"],[UIImage imageNamed:@"25.jpg"],[UIImage imageNamed:@"26.jpg"],[UIImage imageNamed:@"27.jpg"],[UIImage imageNamed:@"28.jpg"],[UIImage imageNamed:@"29.jpg"],[UIImage imageNamed:@"30.jpg"],[UIImage imageNamed:@"31.jpg"],[UIImage imageNamed:@"32.jpg"],[UIImage imageNamed:@"33.jpg"],[UIImage imageNamed:@"34.jpg"],[UIImage imageNamed:@"35.jpg"],[UIImage imageNamed:@"36.jpg"],[UIImage imageNamed:@"37.jpg"],[UIImage imageNamed:@"38.jpg"],[UIImage imageNamed:@"39.jpg"],[UIImage imageNamed:@"40.jpg"],[UIImage imageNamed:@"41.jpg"],[UIImage imageNamed:@"42.jpg"],[UIImage imageNamed:@"43.jpg"],[UIImage imageNamed:@"44.jpg"],[UIImage imageNamed:@"45.jpg"],[UIImage imageNamed:@"46.jpg"],[UIImage imageNamed:@"47.jpg"],[UIImage imageNamed:@"48.jpg"],[UIImage imageNamed:@"49.jpg"],[UIImage imageNamed:@"50.jpg"],[UIImage imageNamed:@"51.jpg"],[UIImage imageNamed:@"52.jpg"],[UIImage imageNamed:@"53.jpg"], nil];
    
    self.mainBackground.animationDuration = 10.0;
    [self.mainBackground startAnimating];
    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)patrolButton:(id)sender {
    [self performSegueWithIdentifier:@"mainToMap" sender:self];
}

- (IBAction)statisticsButton:(id)sender {
    [self performSegueWithIdentifier:@"mainToStatistics" sender:self];
    
}

- (IBAction)reportButton:(id)sender {
    [self performSegueWithIdentifier:@"mainToReport" sender:self];
    
}

@end
